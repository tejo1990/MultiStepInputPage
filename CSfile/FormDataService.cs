using System.Collections.Generic;
using System.Threading.Tasks;
using MultiStepInputPage.Models;

namespace MultiStepInputPage.Services
{
    public class FormDataService : IFormDataService
    {
        public async Task<List<FormData>> GetAllFormDataAsync()
        {
            // 예시 데이터를 반환합니다. 실제 구현에서는 데이터베이스에서 데이터를 가져와야 합니다.
            return await Task.FromResult(new List<FormData>
            {
                new FormData { 
                    BoothNumber = 1, 
                    BeaconId = "BEACON001", 
                    CompanyName = "회사 A", 
                    Title = "혁신적인 제품 A", 
                    Description = "회사 A의 혁신적인 제품에 대한 설명입니다.", 
                    ProductImageUrl = "https://example.com/productA.jpg" 
                },
                new FormData { 
                    BoothNumber = 2, 
                    BeaconId = "BEACON002", 
                    CompanyName = "회사 B", 
                    Title = "획기적인 서비스 B", 
                    Description = "회사 B의 획기적인 서비스에 대한 설명입니다.", 
                    ProductImageUrl = "https://example.com/productB.jpg" 
                },
            });
        }
    }
}